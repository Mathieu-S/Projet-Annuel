<?php

namespace App\Command;

use App\Entity\City;
use App\Entity\Department;
use App\Entity\PostalCode;
use App\Entity\Region;
use App\Common\Helper\TextHelper;
use Exception;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppLoadGeoDataCommand extends ContainerAwareCommand
{
    const BATCH_SIZE = 100;
    const FR_REGIONS_FILE = __DIR__ . '/../../resources/data/regions_fr.csv';
    const FR_DEPARTMENTS_FILE = __DIR__ . '/../../resources/data/departments_fr.csv';
    const FR_CITIES_FILE = __DIR__ . '/../../resources/data/cities_fr.csv';
    protected static $defaultName = 'app:load:geo-data';

    protected function configure()
    {
        $this
            ->setName('data:load-geo-data')
            ->setDescription('Load geo data into DB');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        // Disable SQL logging
        $manager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        // Empty tables before insert
        $this->clearTables();

        // Loading regions
        $output->writeln("\nLoading regions...");
        $count = $this->loadRegions(self::FR_REGIONS_FILE);
        $output->writeln("$count regions loaded.");

        // Loading departments
        $output->writeln("Loading departments...");
        $count = $this->loadDepartments(self::FR_DEPARTMENTS_FILE);
        $output->writeln("$count departments loaded.");

        // Loading cities
        $output->writeln("Loading cities...");
        $this->loadCities($output, self::FR_CITIES_FILE);
    }

    /**
     * @param $regionFile
     * @return int
     */
    protected function loadRegions($regionFile)
    {
        $manager = $this->getContainer()->get('doctrine.orm.entity_manager');
        try {
            $count = $this->loadCsv($regionFile, function ($row) use ($manager) {

                // Create region
                $region = (new Region())
                    ->setCode($row[1])
                    ->setName($row[2])
                    ->setSlug($this->slugify($row[2]));
                $manager->persist($region);
            });
        } catch (Exception $e) {
            var_dump($e);
        }
        $manager->flush();
        $manager->clear();

        return $count;
    }

    /**
     * @param $departmentsFile
     * @return int
     */
    protected function loadDepartments($departmentsFile)
    {

        $manager = $this->getContainer()->get('doctrine.orm.entity_manager');

        try {
            $count = $this->loadCsv($departmentsFile, function ($row) use ($manager) {

                // Find corresponding region
                $region = $manager->getRepository(Region::class)->findOneBy(["code" => $row[7]]);

                // Create department
                $department = (new Department())
                    ->setName($row[3])
                    ->setSlug($this->slugify($row[3]))
                    ->setCode($row[2])
                    ->setRegion($region);

                $manager->persist($department);

            });
        } catch (Exception $e) {
            var_dump($e);
        }
        $manager->flush();
        $manager->clear();
        return $count;
    }

    /**
     * @param OutputInterface $output
     * @param $cityFile
     * @return int
     */
    protected function loadCities(OutputInterface $output, $cityFile)
    {

        $manager = $this->getContainer()->get('doctrine.orm.entity_manager');

        $progress = new ProgressBar($output);
        $progress->start();
        try {
            $count = $this->loadCsv($cityFile, function ($row, $i) use ($manager, $progress) {

                // Find corresponding department
                $department = $manager->getRepository(Department::class)->findOneBy(["code" => $row[1]]);

                // Create a city

                $city = (new City())
                    ->setName($row[5])
                    ->setSlug($this->slugify($row[5]))
                    ->setDepartment($department)
                    ->setLatitude(floatval($row[20]))
                    ->setLongitude(floatval($row[19]));

                // Assign each postal code to this city, all postal codes (in the corresponding CSV file) for one city are assigned to only one column, separated by a '-'
                $postalCodes = explode('-', $row[8]);

                foreach ($postalCodes as $postalCode) {
                    $city->getPostalCodes()->add(
                        (new PostalCode())->setCode($postalCode)->setCity($city)
                    );
                }
                $manager->persist($city);

                if (($i % self::BATCH_SIZE) == 0) {
                    $manager->flush();
                    $manager->clear(PostalCode::class);
                    $manager->clear(City::class);
                }
                $progress->advance();

            });
        } catch (Exception $e) {
            var_dump($e);
        }

        $manager->flush();
        $manager->clear();
        $progress->finish();

        return $count;
    }

    /**
     * @param string $file CSV file path
     * @param $rowCallback Callback executed each row read, takes an array representing a row of a CSV file and a row index
     * @return int
     * @throws Exception
     */
    protected function loadCsv($file, $rowCallback)
    {
        $count = 0;
        $fp = fopen($file, 'r');
        if ($fp === false) {
            throw new Exception('Could not open csv file');
        }
        while (($row = fgetcsv($fp)) !== false) {
            $count++;
            $rowCallback($row, $count);
        }

        return $count;
    }

    protected function clearTables()
    {
        $manager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $manager->getRepository(PostalCode::class)->createQueryBuilder('pc')->delete()->getQuery()->execute();
        $manager->getRepository(City::class)->createQueryBuilder('c')->delete()->getQuery()->execute();
        $manager->getRepository(Department::class)->createQueryBuilder('d')->delete()->getQuery()->execute();
        $manager->getRepository(Region::class)->createQueryBuilder('r')->delete()->getQuery()->execute();
    }

    /**
     * @param $text
     * @return string
     */
    protected function slugify($text)
    {
        $text = TextHelper::slugify($text);

        if (empty($text)) {
            return null;
        }

        return $text;
    }

}
# nginx/Dockerfile
FROM debian:jessie

RUN apt-get update && apt-get install -y nginx

ADD nginx.conf /etc/nginx/
ADD boutique.conf /etc/nginx/sites-enabled/
ADD entrypoint.sh /

RUN rm /etc/nginx/sites-enabled/default
RUN echo "upstream php-upstream { server php_web:9000; }" > /etc/nginx/conf.d/upstream.conf
#RUN service nginx start
CMD ["/bin/sh", "/entrypoint.sh"]
#CMD ["/usr/bin/tail", "-f", "/dev/null"]
EXPOSE 80
EXPOSE 443
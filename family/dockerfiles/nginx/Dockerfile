FROM nginx:1.9

ADD  nginx.conf      /etc/nginx/nginx.conf
ADD  vhost/*    /etc/nginx/conf.d/
RUN  mkdir /opt/www && mkdir /opt/log && mkdir /opt/log/nginx
RUN  chown -R root.root /opt/www /opt/log

VOLUME ["/opt"]

FROM nginx:1.18-alpine

ENV TZ Asia/Tokyo

# nginx config file
COPY ./containers/app/nginx/*.conf /etc/nginx/conf.d/

WORKDIR /var/www/html
FROM nginx:1.17-alpine

COPY ./docker/nginx/default.conf /etc/nginx/conf.d/

EXPOSE 80
COPY ./backend /work
WORKDIR /work
CMD nginx -g "daemon off;"
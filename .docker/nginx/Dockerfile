FROM nginx:latest

COPY ./default.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www

EXPOSE 80 443

CMD ["nginx", "-g", "daemon off;"]
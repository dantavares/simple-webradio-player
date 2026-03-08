FROM php:8.3-fpm-alpine

# instalar nginx e supervisor
RUN apk add --no-cache nginx supervisor

# diretório da aplicação
WORKDIR /var/www/html

# copiar aplicação
COPY app/ /var/www/html/

# copiar configs
COPY nginx.conf /etc/nginx/nginx.conf
COPY supervisord.conf /etc/supervisord.conf

# permissões
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
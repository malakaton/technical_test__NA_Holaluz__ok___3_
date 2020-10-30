FROM nginx:1.17.8-alpine

# Copy the php directory
COPY ./php/ /app/php/

# Copy the nginx config file
COPY ./docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf

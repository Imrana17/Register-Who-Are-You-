# Use an official PHP image with Apache built in
FROM php:8.2-apache

# Copy everything in your project into the server's web folder
COPY . /var/www/html/

# Open port 80 (the web browser port)
EXPOSE 80

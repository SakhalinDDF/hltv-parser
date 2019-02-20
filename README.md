# Install steps

- Run **composer install** in project root
- Run **yarn** or **npm install** in project root
- Update **.env** file with local environment variables
- Run **./yii migrate** for update database schema to working state

# Running web application
- Run **./yii serve localhost:8080** and open browser on current url to access web application
- Generate nginx configuration via **bin/generate-nginx-host.sh** bash script and use application with standalone webserver

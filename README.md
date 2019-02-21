# Install steps

- Run **composer install** in project root
- Run **yarn --production** or **npm install --production** in project root
- Update **.env** file with local environment variables
- Run **./yii migrate** for update database schema to working state

# Running web application
1. Run **./yii serve localhost:8080** and open browser on current url to access web application
2. Or you can use standalone webserver nginx, for generate template of virtual host configuration file use **bin/generate-nginx-host.sh** bash script

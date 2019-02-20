#!/usr/bin/env bash

__FILE__="$(readlink -e ${BASH_SOURCE[0]})"
__DIR__="$(dirname ${__FILE__})"

APP_ROOT="$(dirname ${__DIR__})"
ENV_FILE="${APP_ROOT}/.env"

if [[ ! -f "${ENV_FILE}" ]]; then
    echo "File ${ENV_FILE} should exists";
    exit 1;
fi

. ${ENV_FILE}

APP_CODE=${APP_CODE}
WEB_HOSTNAME=${WEB_HOSTNAME}

cat <<EOT
upstream ${APP_CODE}_php {
    server 127.0.0.1:9000 weight=100 max_fails=5 fail_timeout=5;
}

server {
    listen                  80;
    server_name             ${WEB_HOSTNAME};
    root                    ${APP_ROOT}/frontend/web;
    index                   index.php index.html;

    access_log              /var/log/nginx/${APP_CODE}.access.log;
    error_log               /var/log/nginx/${APP_CODE}.error.log;

    location / {
        try_files \$uri \$uri/ /index.php\$is_args\$args;
    }

    location ~ /\.(ht|git|svn) {
        deny all;
    }

    location ~* ^.+\.(jpg|jpeg|gif|png|svg|ico|css|css\.map|pdf|ppt|txt|bmp|rtf|js|js\.map|vue|otf|ttf|woff|woff2|eot)\$ {
        expires    3d;
        try_files  \$uri =404;
        access_log off;
    }

    location ~\.php\$ {
        try_files               \$uri =404;

        fastcgi_index           index.php;
        fastcgi_pass            ${APP_CODE}_php;
        fastcgi_split_path_info ^(.+\.php)(/.+)\$;

        include fastcgi_params;
    }
}
EOT

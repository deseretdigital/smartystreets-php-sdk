composer-download:
    cmd.run:
        - name: curl -sS https://getcomposer.org/installer | php
        - unless: ls /usr/local/bin/composer
        - require:
            - pkg: php5

mv composer.phar /usr/local/bin/composer:
    cmd.run:
        - unless: ls /usr/local/bin/composer
php5:
    pkg.installed

php5-cli:
    pkg.installed:
        - require:
            - pkg: php5

php-pear:
    pkg.installed:
        - require:
            - pkg: php5

php5-xdebug:
    pkg.installed:
        - require:
            - pkg: php5

php5-curl:
    pkg.installed:
        - require:
            - pkg: php5

php-soap:
    pkg.installed:
        - require:
            - pkg: php5
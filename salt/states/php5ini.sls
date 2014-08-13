
/etc/php5/cli/php.ini:
    file.managed:
        - source: salt://server_configs/etc/php5/cli/php.ini
        - user: root
        - group: root
        - mode: 644
        - require:
            - pkg: php5

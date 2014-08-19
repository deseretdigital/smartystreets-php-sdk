/home/vagrant/.bash_aliases:
    file.managed:
        - source: salt://server_configs/home/vagrant/.bash_aliases
        - user: vagrant
        - group: admin
        - mode: 654

/etc/vim/vimrc.local:
    file.managed:
        - source: salt://server_configs/etc/vim/vimrc.local
        - user: vagrant
        - group: admin
        - mode: 644
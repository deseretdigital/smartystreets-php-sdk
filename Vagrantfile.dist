# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

  # Basic Configs
  # @TODO: Find a place to host the box so that vagrant can download it when vagrant up is run
  #config.vm.box_url = "https://sharefile.deseretnews.com/download.ashx?dt=dtd1f3185aeb75449bac48c02d9afa4438&h=vLZSIDUQw2eqLbB2jzaFbBTLANjANhLsdflorIDkeTI="
  config.vm.box = "debian-7.2.0"
  config.vm.network :private_network, ip: "192.168.50.10"

  # Synced Folders
  config.vm.synced_folder "../smartystreets-php-sdk", "/var/www/smartystreets", type: "nfs"

  config.vm.synced_folder ".", "/vagrant", type: "nfs"

  # Salt Provisioning
  config.vm.synced_folder "salt/", "/srv/salt", type: "nfs"

  config.vm.provision :salt do |salt|
    salt.minion_config = "salt/minion"
    salt.run_highstate = true
    salt.verbose = true
  end

  # Advanced Configs
  config.vm.provider :virtualbox do |vb|
    vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    vb.customize ["modifyvm", :id, "--natdnsproxy1", "on"]
    vb.customize ["modifyvm", :id, "--memory", "1024"]
  end

end

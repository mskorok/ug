Vagrant.configure(2) do |config|
    config.vm.box = "urlaubs-gluck"
    config.vm.box_url = "http://boxes.kodex.lv/urlaubs-gluck"
    config.ssh.private_key_path = "./resources/vagrant/ugluck_rsa"
    
    config.vm.define "ug" do |ug|
    end
    
    config.vm.network "private_network", ip: "192.168.200.200"
    config.vm.network "forwarded_port", guest: 80, host: 8081
    
    config.vm.provider :virtualbox do |vb|
        vb.customize ["modifyvm", :id, "--memory", "1536"]
        vb.customize ["modifyvm", :id, "--cpus", "2"]
        vb.customize ["modifyvm", :id, "--ioapic", "on"]
    end

    config.bindfs.bind_folder "/vagrant", "/vagrant",
        perms: "u=rwX:g=rwX:o=rD",
        :'chown-ignore' => true, :'chgrp-ignore' => true, :'chmod-ignore' => true
end


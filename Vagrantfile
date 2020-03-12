# -*- mode: ruby -*-
# vi: set ft=ruby :

require 'yaml'

def cpu_count
  host = RbConfig::CONFIG['host_os']
  # Give VM access to all cpu cores on the host
  if host =~ /darwin/
    `sysctl -n hw.ncpu`.to_i
  elsif host =~ /linux/
    `nproc`.to_i
  else # sorry Windows folks, I can't help you
    1
  end
end

DEFAULTS = {
  'box' => 'ubuntu/bionic64',
  'memory' => 1536,
  'cpus' => cpu_count,
  'env' => {},
  'wordpress_port_guest' => 8000,
  'wordpress_port_host' => 8000,
  'phpmyadmin_port_guest' => 3000,
  'phpmyadmin_port_host' => 3000,
  'mailhog_port_guest' => 8025,
  'mailhog_port_host' => 8025
}

# If you want to override any of the above DEFAULTS, you can define
# key/value pairs in a YAML file at `.vagrant.yml` in the current directory.
settings_file_path = File.dirname(__FILE__) + '/.vagrant.yml'
settings_file = if File.exist?(settings_file_path)
  YAML.load(File.read(settings_file_path))
else
  {}
end

SETTINGS = DEFAULTS.merge(settings_file).freeze

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = SETTINGS['box']

  config.vm.provider 'virtualbox' do |vb|
    vb.customize ['modifyvm', :id, '--memory', SETTINGS['memory']]
    vb.customize ['modifyvm', :id, '--cpus', SETTINGS['cpus']]
  end

  config.vm.network :forwarded_port, guest: SETTINGS['wordpress_port_guest'], host: SETTINGS['wordpress_port_host']
  config.vm.network :forwarded_port, guest: SETTINGS['phpmyadmin_port_guest'], host: SETTINGS['phpmyadmin_port_host']
  config.vm.network :forwarded_port, guest: SETTINGS['mailhog_port_guest'], host: SETTINGS['mailhog_port_host']

  config.vm.synced_folder ".", "/home/vagrant/shared", :owner => "vagrant", :group => "vagrant"

  # So that provisioning scripts can access private Git repos.
  # config.ssh.forward_agent = true

  config.vm.provision :shell,
    :privileged => false,
    :env => SETTINGS['env'],
    :inline => "/home/vagrant/shared/provision/provision.sh"

  # config.vm.provision :shell,
  #   :privileged => false,
  #   :env => SETTINGS['env'],
  #   :inline => "cd /home/vagrant/wordpress; /home/vagrant/shared/bin/fixture.sh"

  # Starting Apache automatically on boot (eg: with `update-rc.d`) is tricky
  # because we store our Apache config files in /vagrant, which only gets
  # mounted *after* Ubuntu attempts to start Apache, resulting in Apache
  # ignoring those files. The simple alternative is to get Vagrant to start
  # the Apache server manually, every time it finishes upping the VM.
  config.vm.provision :shell,
    :run => "always",
    :inline => "service apache2 restart"

end

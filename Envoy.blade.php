@servers(['web-1' => 'staging:one', 'web-2' => 'staging:two'])

<?php $what = 'Okay? Deploying!'; ?>

@macro('ready-server')
    test
    update
    server-setup
    hhvm
    composer
@endmacro

@task('test', ['on' => ['web-1', 'web-2'], 'parallel' => true])
    echo {{ $what }}
@endtask

@task('update', ['on' => ['web-1', 'web-2'], 'parallel' => true])
    sudo apt-get update
@endtask

@task('server-setup', ['on' => ['web-1', 'web-2'], 'parallel' => true, 'confirm' => true])
    sudo apt-get install nginx mysql-client git curl software-properties-common
@endtask

@task('hhvm', ['on' => ['web-1', 'web-2'], 'parallel' => true, 'confirm' => true])
    sudo apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0x5a16e7281be7a449
    sudo add-apt-repository 'deb http://dl.hhvm.com/ubuntu trusty main'
    sudo apt-get update
    sudo apt-get install hhvm
    sudo update-rc.d hhvm defaults
    sudo /usr/share/hhvm/install_fastcgi.sh
    sudo service hhvm restart
    sudo service nginx restart
@endtask

@task('composer', ['on' => ['web-1', 'web-2'], 'parallel' => true])
    curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/bin --filename=composer
@endtask
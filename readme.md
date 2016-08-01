## Инсталација
Потребно е да се инсталира Laravel Homestead, виртуелна машина која ги содржи сите потребни алатки за користење на Laravel.

За да се користи Laravel потребно е да се спушти Composer, а Virual Box и Vagrant ќе се користат за Homestead виртуелната машина.

1. https://getcomposer.org/download/
2. https://www.virtualbox.org/wiki/Downloads
3. https://www.vagrantup.com/downloads.html
4. Во windows за полесно да се инсталира се треба и ова: https://git-for-windows.github.io/ 

Откако ќе се инсталираат Composer, VirtualBox, Vagrant и Git, во git bash внеси:

5. composer global require "laravel/installer"
6. vagrant box add laravel/homestead
    - Oтприлика 1 gb ќе спушти
7. cd && git clone https://github.com/laravel/homestead.git Homestead
8. cd Homestead/ && bash init.sh

Следно треба да се конфигурира Homestead и hosts фајлот. Секаде каде што пишува Aleksandar смени со името на user-ot на компјутерот.

9. C:\Users\Aleksandar\.homestead\Homestead.yaml кај мене изгледа вака: линк
    - Moже да се смени овој фајл. Повеќе [овде](https://laravel.com/docs/5.2/homestead#configuring-homestead). Ако останува исто вака тогаш во gti bash внеси:
     - cd && mkdir code
10. C:\Windows\System32\drivers\etc\hosts кај мене изгледа вака: линк.
    - Пази на празни места и табови. Може да прави проблеми.

Останува уште ssh да се намести и да се клонира проектот. Во git bash:
11. ssh-keygen -t rsa -b 4096
    - Ќе врати: Enter a file in which to save the key (/Users/you/.ssh/id_rsa): [Press enter] 
    - Стисни enter за да остане default.
    - Потоа може да се внесе passphrase ама не мора. 
12. cd && cd code && git clone https://github.com/DummyTrip/ticket-sale.git 

Сега се е спремно. Треба да се пушти Homestead, да се наполни базата и да се пушти во browser timska.dev.
Во git bash внеси:

1. cd && cd code && git clone https://github.com/DummyTrip/ticket-sale.git
2. cd && cd Homestead
3. vagrant up
4. vagrant ssh
5. cd Code/ticket-sale 
6. php artisan migrate --seed
7. Во browser внеси: 
    - timska.dev

Кога ќе се заврши со работа треба да се исклучи Homestead.

9. exit
10. vagrant halt

## Official Laravel Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).


@servers(['web' => 'craig@do'])

@task('tail')
cd /var/www/html/bestintown.co/current
tail -f storage/logs/laravel.log
@endtask

@task('pull')
    cd /var/www/html/bestintown.co/current
    php artisan bestintown:pull
    php artisan bestintown:cluster
@endtask

@task('reseed')
    cd /var/www/html/bestintown.co/current
    php artisan migrate:refresh --seed
    php artisan bestintown:pull
    php artisan bestintown:cluster
@endtask

@task('recluster')
    cd /var/www/html/bestintown.co/current
    php artisan bestintown:cluster
@endtask

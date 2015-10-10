@servers(['web' => 'craig@do'])

@task('pull')
    cd /var/www/html/bestintown.co/current
    php artisan bestintown:pull
    php artisan bestintown:cluster
@endtask

@task('recluster')
    cd /var/www/html/bestintown.co/current
    php artisan bestintown:cluster
@endtask
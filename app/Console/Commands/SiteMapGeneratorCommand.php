<?php

namespace App\Console\Commands;

use App\Models\Service;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class SiteMapGeneratorCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'sitemap:generate';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description';

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    $services = Service::approved()->get();
    $mainUrl = 'https://berlindeyiz.de';
    $sitemapGenerator = SitemapGenerator::create($mainUrl)
      ->getSitemap();

    $filePath = App::isLocal() ? '/Users/enversanli/PhpstormProjects/berlindeyiz/berlindeyiz-front/public/sitemap.xml' : '/var/www/berlindeyiz-front/public/sitemap.xml';

      $otherPages = [
      'sikca-sorulan-sorular',
      'etkinlikler',
      'duyurular',
      'doktorlar',
      'avukatlar',
      'kurum-kurulus-ve-mekanlar',
    ];

      $counter = 0;
      $this->error('Basliyor...');
      foreach ($otherPages as $otherPage) {
        $fullUrl = $mainUrl . '/'.$otherPage;

        $sitemapGenerator->add(Url::create($fullUrl)->setPriority(0.5));
        $this->info('Added To Sitemap : ' . $otherPage);
        $counter++;
    }

      foreach ($services as $service) {
        $url = $mainUrl . '/'.$service->type->slug . '/' . $service->slug;

        $sitemapGenerator->add(Url::create($url)->setPriority(0.5));
        $this->info('Added To Sitemap : ' . $url);
        $counter++;
    }

      $sitemapGenerator->writeToFile($filePath);

      $this->error('Sitemap Genereted, Please check...');
    $this->info("{$counter} page stored to sitemap.");
  }
}

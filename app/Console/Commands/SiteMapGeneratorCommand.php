<?php

namespace App\Console\Commands;

use App\Models\Service;
use Illuminate\Console\Command;
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
    $sitemapGenerator = SitemapGenerator::create('https://berlindeyiz.de')
      ->getSitemap();

    $otherPages = [
      '/sikca-sorulan-sorular',
      '/duyurular',
    ];

    foreach ($otherPages as $otherPage) {
      $sitemapGenerator->add(Url::create($otherPage)->setPriority(0.5));
    }

    foreach ($services as $service) {
      $url = '/etkinlikler/' . $service->slug;

      $sitemapGenerator->add(Url::create($url)->setPriority(0.5));
    }
    $sitemapGenerator->
    writeToFile('sitemap.xml');

  }
}

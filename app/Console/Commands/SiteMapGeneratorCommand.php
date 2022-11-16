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
    foreach ($services as $service) {
      $url = '/etkinlikler/' . $service->slug;

      // here we add one extra link, but you can add as many as you'd like
      $sitemapGenerator->add(Url::create($url)->setPriority(0.5));
    }
    $sitemapGenerator->
    writeToFile('sitemap.xml');

  }
}

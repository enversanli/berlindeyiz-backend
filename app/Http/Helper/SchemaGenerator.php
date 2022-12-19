<?php

namespace App\Http\Helper;

use App\Models\Service;
use Carbon\Carbon;

class SchemaGenerator
{
  public function generate(Service $service): array
  {
    $type = $this->getType($service->type->slug);
    $date = Carbon::parse($service->date_from . ' ' . $service->start_time);

    return [
      "@context" => "http://schema.org",
      "@type" => $type,
      "name" => $service->title,
      "startDate" => $date,
      "location" => [
        "@type" => "Place",
        "address" => [
          "@type" => "PostalAddress",
          "addressLocality" => $service->city->name
        ]
      ],
      "image" => "https://berlindeyiz.de/storage/{$service->logo}",
      "url" => config('app.url') . $service->type->title . "/{$service->slug}"
    ];

  }

  private function getType(string $type): string
  {
    return match ($type) {
      'etkinlikler' => 'Event',
      'doktorlar' => 'LocalBusiness',
      'avukatlar' => 'LocalBusiness',
    };
  }
}
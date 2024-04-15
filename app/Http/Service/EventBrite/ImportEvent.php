<?php

namespace App\Http\Service\EventBrite;

use App\Models\City;
use App\Models\Service;
use App\Support\Enum\ServiceStatusEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ImportEvent
{
    protected string $eventsEndpoint = 'https://www.eventbriteapi.com/v3/events/';

    public function getByEventId(string $externalEventId): mixed
    {

        $event = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.event-brite.token'),
        ])
            ->get($this->eventsEndpoint . $externalEventId . '?expand=venue,ticket_availability')?->object();

        if (isset($event->status_code) && $event->status_code == 404) {
            abort(404, 'Cannot be found');
        }

        $data = [
            'user_id' => 1,
            'business_id' => 1,
            'category_id' => 1,
            'type_id' => 1,
            'title' => $event->name->text,
            'slug' => Str::slug($event->name->text) . '-' . now()->timestamp,
            'text' => $event->summary,
            'date_from' => Carbon::make($event->start->local)->format('Y-m-d'),
            'date_to' => Carbon::make($event->end->local)->format('Y-m-d'),
            'start_time' => Carbon::make($event->start->local)->format('H:i:s'),
            'end_time' => Carbon::make($event->end->local)->format('H:i:s'),
            'status' => ServiceStatusEnum::ACTIVE,
            'logo' => $event->logo->url,
            'image' => $event->logo->url,
            'price' => !$event->is_free && $event->ticket_availability->has_available_tickets ? $event->ticket_availability->minimum_ticket_price->major_value : 0,
            'is_priced' => $event->is_free,
            'city_id' => City::where('name', 'Berlin')->first()?->id ?? 1,
            'district_id' => null,
            'address' => $event->venue->address->localized_address_display,
            'meta' => ['ticket' => $event->url]
        ];

        $service = Service::create($data);

        return $service;
    }
}
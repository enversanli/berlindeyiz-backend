<?php

namespace App\Http\Controllers;

use App\Http\Service\EventBrite\ImportEvent;
use App\Http\Service\Importer\EventBriteImporterService;
use App\Support\ResponseMessage;
use Facades\App\Http\Actions\ServiceImporter\ServiceImportAction;
use Illuminate\Http\Request;

class ServiceImporterController extends Controller
{
    public function __construct(protected ImportEvent $eventBriteImporterService)
    {

    }

    public function import($externalEventId)
    {
        $importedEvent = $this->eventBriteImporterService->getByEventId($externalEventId);

        return redirect()->route('service.show', $importedEvent->id);
    }
}

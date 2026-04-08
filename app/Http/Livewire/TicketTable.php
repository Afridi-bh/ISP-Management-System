<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Ticket;

class TicketTable extends DataTableComponent
{
    protected $model = Ticket::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setAdditionalSelects(['tickets.id as id'])
            ->setTableRowUrl(function($row) {
                return route('ticket.show', $row);
            });
    }

    public function columns(): array
    {
        return [
            Column::make("Ticket ID", "number")
                ->sortable()
                ->searchable(),
            Column::make("Subject", "subject")
                ->sortable()
                ->searchable(),
            Column::make("Status", "status")
                ->sortable()
                ->format(function($value) {
                    $colors = [
                        'Open' => 'bg-blue-100 text-blue-800',
                        'Closed' => 'bg-gray-100 text-gray-800',
                        'Pending' => 'bg-yellow-100 text-yellow-800',
                    ];
                    $color = $colors[$value] ?? 'bg-gray-100 text-gray-800';
                    return '<span class="px-2 py-1 text-xs font-semibold rounded-full ' . $color . '">' . $value . '</span>';
                })
                ->html(),
            Column::make("Priority", "priority")
                ->sortable()
                ->format(function($value) {
                    $colors = [
                        'Urgent' => 'bg-red-100 text-red-800',
                        'High' => 'bg-orange-100 text-orange-800',
                        'Medium' => 'bg-yellow-100 text-yellow-800',
                        'Low' => 'bg-green-100 text-green-800',
                    ];
                    $color = $colors[$value] ?? 'bg-gray-100 text-gray-800';
                    return '<span class="px-2 py-1 text-xs font-semibold rounded-full ' . $color . '">' . $value . '</span>';
                })
                ->html(),
            Column::make("Created by", "ticketable_id")
                ->format(function($value, $row) {
                    $creator = $row->ticketable;
                    if (!$creator) return 'N/A';
                    
                    $type = $row->isCustomerTicket() ? 'Customer' : 'Staff';
                    $badgeColor = $row->isCustomerTicket() ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800';
                    
                    return $creator->name . ' <span class="ml-1 px-2 py-0.5 text-xs font-semibold rounded-full ' . $badgeColor . '">' . $type . '</span>';
                })
                ->html(),
            Column::make("Created at", "created_at")
                ->sortable()
                ->format(function ($value) {
                    return Carbon::parse($value)->format('M d, Y H:i');
                }),
        ];
    }

    public function builder(): Builder
    {
        // For admin users, show all tickets
        if (auth()->check() && auth()->user()->role === 'admin') {
            return Ticket::query()->with(['ticketable']);
        }

        // For regular users, show only their tickets
        if (auth()->check() && auth()->user()->isUser()) {
            return Ticket::query()
                ->where('ticketable_type', 'App\\Models\\User')
                ->where('ticketable_id', auth()->id())
                ->with(['ticketable']);
        }

        // Default: show all tickets (for admin)
        return Ticket::query()->with(['ticketable']);
    }
}
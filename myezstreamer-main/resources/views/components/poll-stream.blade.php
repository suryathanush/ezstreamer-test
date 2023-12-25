<div wire:poll>
    @php
    $status_results = shell_exec("stream_stats.sh -s$stream_id $statsToGet");
    echo $status_results;
    @endphp 
</div>

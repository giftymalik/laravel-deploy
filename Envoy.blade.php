@servers(['web-1' => 'staging:one', 'web-2' => 'staging:two'])

<?php $what = 'Okay? Deployed!'; ?>

@task('deploy', ['on' => ['web-1', 'web-2'], 'parallel' => true])
    echo {{ $what }}
@endtask
<?php

it('can execute make:repository command', function () {
    $this->artisan('make:repository Test')
        ->assertExitCode(0);
});

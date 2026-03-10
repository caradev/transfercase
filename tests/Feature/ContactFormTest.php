<?php

use App\Livewire\ContactForm;
use App\Mail\ContactInquiryMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

it('requires all mandatory fields', function () {
    Livewire::test(ContactForm::class)
        ->call('submit')
        ->assertHasErrors(['name', 'email', 'message']);
});

it('can submit a contact inquiry with correct captcha', function () {
    Mail::fake();

    $component = Livewire::test(ContactForm::class);

    // Get the captcha answer from the component
    $answer = $component->get('captcha_expected_answer');

    $component->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('message', 'This is a test message from a human.')
        ->set('captcha_answer', (string) $answer)
        ->call('submit')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('contact_inquiries', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'message' => 'This is a test message from a human.',
    ]);

    Mail::assertSent(ContactInquiryMail::class);
});

it('fails to submit with incorrect captcha', function () {
    Mail::fake();

    $component = Livewire::test(ContactForm::class);

    // Get the captcha answer and use a wrong one
    $answer = (int) $component->get('captcha_expected_answer');
    $wrongAnswer = $answer + 1;

    $component->set('name', 'Bot')
        ->set('email', 'bot@example.com')
        ->set('message', 'I am a bot trying to spam.')
        ->set('captcha_answer', (string) $wrongAnswer)
        ->call('submit')
        ->assertHasErrors(['captcha_answer']);

    $this->assertDatabaseMissing('contact_inquiries', [
        'name' => 'Bot',
    ]);

    Mail::assertNotSent(ContactInquiryMail::class);
});

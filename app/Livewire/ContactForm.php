<?php

namespace App\Livewire;

use App\Mail\ContactInquiryMail;
use App\Models\ContactInquiry;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactForm extends Component
{
    public $name = '';

    public $email = '';

    public $phone = '';

    public $subject = '';

    public $message = '';

    public $captcha_question = '';

    public $captcha_expected_answer = '';

    public $captcha_answer = '';

    public function mount()
    {
        $this->generateCaptcha();
    }

    public function generateCaptcha(): void
    {
        $number1 = rand(1, 10);
        $number2 = rand(1, 10);
        $this->captcha_question = "{$number1} + {$number2}";
        $this->captcha_expected_answer = (string) ($number1 + $number2);
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
            'captcha_answer' => ['required', 'string', function ($attribute, $value, $fail) {
                if ($value !== $this->captcha_expected_answer) {
                    $fail('The captcha answer is incorrect.');
                }
            }],
        ];
    }

    public function submit()
    {
        $this->validate();

        try {
            // Create inquiry in database
            $inquiry = ContactInquiry::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'subject' => $this->subject,
                'message' => $this->message,
            ]);

            // Send email to info@cara.dev
            Mail::to(config('mail.to.address'))->send(new ContactInquiryMail($inquiry));

            session()->flash('success', 'Thank you for contacting us! We will get back to you as soon as possible.');

            // Reset form
            $this->reset(['name', 'email', 'phone', 'subject', 'message', 'captcha_answer']);
            $this->generateCaptcha();
        } catch (\Exception $e) {
            session()->flash('error', 'There was an error submitting your inquiry. Please try again or call us directly.');
            \Log::error('Contact form error: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}

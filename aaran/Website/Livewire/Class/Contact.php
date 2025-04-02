<?php

namespace Aaran\Website\Livewire\Class;

//use Aaran\Assets\Traits\CommonTraitNew;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Contact extends Component
{
//    use CommonTraitNew;

    public $email;
    public $phone;
    public $subject;
    public $message;

    public function mount()
    {
        $this->common->active_id = 1;
    }

    public function rules(): array
    {
        return [
            'common.vname' => 'required|min:3',
            'email' => 'required|email|unique:demo_requests,email',
            'phone' => 'required|numeric|digits:10|unique:demo_requests,phone',
        ];
    }

    public function messages()
    {
        return [
            'common.vname.required' => ' :attribute is required.',
            'email.required' => ' :attribute is required.',
            'phone.required' => ' :attribute is required.',

        ];
    }

    public function validationAttributes()
    {
        return [
            'common.vname' => 'User name',
            'email' => 'Email Id',
            'phone' => 'Phone No',
        ];
    }

    #region[Get-Save]
    public function getSave(): void
    {
        $this->validate($this->rules());

        if ($this->common->vname != '') {
            if ($this->common->vid == '') {
//                $DemoRequest = new DemoRequest();
                $extraFields = [
                    'phone' => $this->phone,
                    'email' => $this->email,
                    'subject' => $this->subject,
                    'message' => $this->message,
                ];
                $this->common->save($DemoRequest, $extraFields);
                $message = "Saved";
            }
            $this->dispatch('notify', ...['type' => 'success', 'content' => $message . ' Successfully']);
        }
        $this->clearFields();
    }
    #endregion

    #region[Get-Obj]
    public function getObj($id)
    {
        if ($id) {
//            $DemoRequest = DemoRequest::find($id);
            $this->common->vid = $DemoRequest->id;
            $this->common->vname = $DemoRequest->vname;
            $this->phone = $DemoRequest->phone;
            $this->email = $DemoRequest->email;
            $this->subject = $DemoRequest->subject;
            $this->message = $DemoRequest->message;
            return $DemoRequest;
        }
        return null;
    }
    #endregion

    #region[Clear-Fields]
    public function clearFields(): void
    {
        $this->common->vid = '';
        $this->common->vname = '';
        $this->phone = '';
        $this->email = '';
        $this->subject = '';
        $this->message = '';
        $this->common->active_id = 1;
    }

    #endregion

    #[Layout('Ui::components.layouts.web')]
    public function render()
    {
        return view('website::contact');
    }

}

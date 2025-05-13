<?php

namespace Aaran\Website\Livewire\Class;

use FontLib\Table\Type\name;
use Livewire\Attributes\Layout;
use Livewire\Component;
use phpDocumentor\Reflection\DocBlock\Description;

class Service extends Component
{

    #[Layout('Ui::components.layouts.web')]
    public function render()
    {
        $services = [
            (object)[
                'image' => 'images/home/wall1.webp',
                'title' => 'Web Development Services',
                'description' => 'Custom, responsive websites and web applications tailored to your business needs.'
            ],
            (object)[
                'image' => 'images/home/wall1.webp',
                'title' => 'Mobile App Development',
                'description' => 'Design and development of native and cross-platform mobile apps for Android and iOS.'
            ],
            (object)[
                'image' => 'images/home/wall1.webp',
                'title' => 'Cloud & DevOps',
                'description' => 'Cloud migration, CI/CD pipelines, and scalable infrastructure management.'
            ],
            (object)[
                'image' => 'images/home/wall1.webp',
                'title' => 'AI & Data Services',
                'description' => 'AI-powered solutions, data analysis, and intelligent automation for business insights.'
            ],
            (object)[
                'image' => 'images/home/wall1.webp',
                'title' => 'Cybersecurity Services',
                'description' => 'Security assessments, threat mitigation, and data protection for digital assets.'
            ],
            (object)[
                'image' => 'images/home/wall1.webp',
                'title' => 'API Development & Integration',
                'description' => 'Secure and scalable APIs for seamless system and third-party service integration.'
            ],
            (object)[
                'image' => 'images/home/wall1.webp',
                'title' => 'ERP & CRM Software',
                'description' => 'Custom ERP and CRM solutions to streamline operations and manage customer relationships.'
            ],
            (object)[
                'image' => 'images/home/wall1.webp',
                'title' => 'Technical Support & Maintenance',
                'description' => 'Ongoing support, troubleshooting, and maintenance to ensure system reliability.'
            ],
        ];

        $reviews =[
            (object)['image'=>'images/home/wall1.webp','name'=>'HARIS','job'=>'Tester','description'=>'Good Project'],
            (object)['image'=>'images/home/wall1.webp','name'=>'SARAN','job'=>'Developer','description'=>'Good Project'],
            (object)['image'=>'images/home/wall1.webp','name'=>'HARIS','job'=>'Tester','description'=>'Good Project'],
            (object)['image'=>'images/home/wall1.webp','name'=>'SARAN','job'=>'Developer','description'=>'Good Project'],
        ];
        return view('website::service', compact('services'),compact('reviews'));
    }

}

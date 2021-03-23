<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests;
use Illuminate\Http\Request;

use DB;

class ContentController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the homepage
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    public function open_a_store() {
        
        \View::share('store', []);
        \View::share('appearance', []);
        \ViewHelper::setPageDetails('Storefronts | Open a Store', 'Open a Store');
        return view('frontend.page.open-a-store', ['pageTitle' => 'Open a Store' ]);
        
    }
	
	public function page($storeslug, $pageslug) {
		

        // ownai terms and conditions
        // ownai faq

        $store = $this->getStoreBySlug($storeslug);
        if ($store) {
            
            \View::share('store', $store);
            $appearance =  DB::table('store_appearance')->where('store_id', $store->id)->first();

       
            \View::share('appearance', $appearance);

        }else{
             \View::share('store', []);
             \View::share('appearance', []);
        }

        

        switch ($pageslug) {
            case "privacy":
                \ViewHelper::setPageDetails('Storefronts | Privacy', 'Privacy');
                return view('frontend.page.privacy', ['pageTitle' => 'Privacy']);
                break;
            case "cookies":
                \ViewHelper::setPageDetails('Storefronts | Cookies', 'Cookies');
                return view('frontend.page.cookies', ['pageTitle' => 'Cookies']);
                break;
            case "faq":
                \ViewHelper::setPageDetails('Storefronts | FAQs', 'FAQs');
                return view('frontend.page.faq', ['pageTitle' => 'FAQs']);
                break;
            case "terms-and-conditions":
                \ViewHelper::setPageDetails('Storefronts | Terms &amp; Conditions', 'Terms &amp; Conditions');
                return view('frontend.page.t-and-c', ['pageTitle' => 'Terms &amp; Conditions']);
                break;
            case "open-a-store":
                \ViewHelper::setPageDetails('Storefronts | Open a Store', 'Open a Store');
                return view('frontend.page.open-a-store', ['pageTitle' => 'Open a Store' ]);
            default:
                \App::abort(404);
        }

	}
}

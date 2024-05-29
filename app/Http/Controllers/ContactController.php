<?php
    namespace App\Http\Controllers;
    use Illuminate\Routing\Controller as BaseController;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Http\Request;
    use App\Models\Messages;
    use Carbon\Carbon;
    use Response;
    use Log;
    use Auth;
    use View;

    class ContactController extends BaseController{
    
        public function contact(){
            return view('contact', []);
        }
        public function contacteaza(Request $request){
            $validatedData = $request->validate([
                'firstName' => 'required',
                'lastName' => 'required',
                'contactEmail' =>'required|email',
                'message' =>'required'
            ], [
                'firstName.required' => 'Introduceti nume',
                'lastName.required' => 'Introduceti prenume',
                'message.required' => 'Introduceti un mesaj',
                'contactEmail.required' => 'Introduceți adresa de email asociată contului dvs.',
                'contactEmail.email' => 'Introduceți o adresă de email corectă'
            ]);
            
            
        }
    }

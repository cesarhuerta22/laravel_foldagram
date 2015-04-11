<?php

class FoldagramsController extends BaseController {

    public function postCreate() {
        $foldagram = new Foldagram;        
        $foldagram->message = Input::get('message');
        $foldagram->save();
        
        if(Input::hasFile('image')){
            $image = Input::file('image');
            $filename = $foldagram->id.
                "_".
                str_random(8).
                ".".
                $image->getClientOriginalExtension()
            ;

            $destinationPath = 'img/uploads';
            $thumbnailPath = 'img/thumbnails/'.$filename;

            Input::file('image')->move($destinationPath, $filename);

            Image::make($destinationPath.'/'.$filename)
                ->resize(10, 100)
                ->save($thumbnailPath);

            $foldagram->image = $filename;
            $foldagram->save();
        }
        
        
        $recipients_input = Input::get('add');
        
        if(!empty($recipients_input)){
            
            $recipients = array();
            
            foreach($recipients_input as $value){
                $recipient = new Recipient(array(
                    'fullname' => $value['fullname'],
                    'address_one' => $value['address_one'],
                ));
                
                $foldagram->recipients()->save($recipient);
            }
        }
        
        try{
            $qty = count(Input::get('add'));
            
            $item = array(
                'id'            => $foldagram->id,
                'quantity'      =>$qty,
                'price'         =>Config::get('foldagram.price'),
                'name'          =>'Foldagram'
            );
            
            //Add the item to the shopping cart
            Cart::insert($item);
            $identifier = key(array_slice(Cart::contents(), -1, 1, TRUE));
            
            return Redirect::route('/')
                    ->with('id', $foldagram->id)
                    ->with('identifier', $identifier)
                    ->with('dsuccess', "Your Foldagram Has Saved")
                    ->with('redirect', "preview");
        } catch (Exception $ex) {
            return Redirect::route('/')->with('error', $ex->getMessage());
        }
    }
    
    public function removeAddress($id='', $identifier = '') {
        if(empty($id) && empty($identifier)){
            return Redirect::to('/')
                ->with('dsuccess', "Foldagram Recipient Address not found")
                ->with('redirect', "preview");
        }
        
        try{
            $item = Cart::item($identifier);
            if($item->total() > Config::get('foldagram.price')){
                $raddress = Recipient::where('id', '=', $id)->delete();
                if($raddress){
                    $total_item = floor($item->total()/Config::get('foldagram.price'));
                    
                    $total_item = $total_item - 1;
                    
                    
                    //Get the items to be updated
                    if(!empty($total_item)){
                        
                        $item->quantity = $total_item;
                        
                        //Redirect to the cart page
                        return Redirect::to('/')
                            ->with('dsuccess', "The Foldagram Recipient Address has been removed")
                            ->with('id', $item->id)
                            ->with('identifier', $identifier)    
                            ->with('redirect', "preview");  
                    } else {
                        return Redirect::to('/')
                            ->with('derror', "At least one recipient address required")
                            ->with('id', $item->id)
                            ->with('identifier', $identifier)    
                            ->with("redirect", "preview");
                    }
                    
                } else {
                    return Redirect::to('/')
                        ->with('derror', "Recipient Address not found")
                        ->with('id', $item->id)
                        ->with('identifier', $item->$identifier)
                        ->with("redirect", "preview");
                }
            } else {
                return Redirect::to('/')
                    ->with('derror', "In Foldagram at least one Recipient Address Required.")
                    ->with('id', $item->id)
                    ->with('identifier', $identifier)
                    ->with("redirect", "preview");
            }
        } catch (Exception $ex) {
            return Redirect::to('/')->with('perror', $ex->getMessage());
        }
    }
}

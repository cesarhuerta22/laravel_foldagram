<div id="recipient_address" style="display:none;">
    <div class="recipient_address" id="recip_aid">
        <h3>
            Recipient's Address 
            <span class="acount">- rone</span>
        </h3>
        <input placeholder="Full Name* :" class="required" type="text"
            name="add[zero][fullname]" value="">
        {{ Form::textarea("add[zero][address_one]", null, array(
            'size' => '50x8',
            'placeholder' => "Enter Recipient's Address here:",
            'class' => 'required'
        )) }}
    </div>
</div>
<div id="popup" class="modal hide fade" tabindex="-1" role="dialog" 
    aria-labelledby="myModalLabel" aria-hidden="false" style="display: block;">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <div class="modal-body">
            
            @if(Session::has('psuccess'))
                <div class="alert alert-success">
                    {{ Session::get('psuccess') }}
                </div>
            @endif
            @if(Session::has('perror'))
                <div class="alert alert-error">
                    {{ Session::get('perror') }}
                </div>
            @endif
            <div class="cfrom-wapper">
                <img src="{{ asset('img/create-form-flow.png') }}"/>
                {{ Form::open(array('url' => URL::route('create'), 'files' => true )) }}
                    <div class="setp1">
                        <div class="message create-form">
                            
                            {{ Form::textarea('message', null, array(
                                'size' => '50x4',
                                'placeholder' => "Enter Your Message",
                                'class' => 'enter-message required'
                            ))}}
                            <br>You have <span id="charsLeft">1200</span> chars left.
                            <div class="clear"></div>
                            <div id="thumbnail">
                                <img src="{{ asset('img/placehold.gif') }}" />
                            </div>
                            <input type="file" style="display: none;" id="upload-image" 
                                name="image" class="required" />
                            <div id="upload" class="drop-area">
                                <span class="uploadfile">Upload File</span>
                                <p class="help-block">
                                    Files must be less than <span>8 MB</span>
                                </p>
                                <p class="help-block">
                                    Allowed file types: <span>png gif jpg jpeg</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="address">
                        <div class="photocreate-form recipient_address_wapper">
                            <!-- daynamic content  by jqueyr add more -->
                        </div>
                    </div>
                    <div class="submit">
                        <div class="submit-content">
                            <button class="add btn-large btn" type="button">
                                Add Another Address
                            </button>
                            <button class="remove btn-large btn" type="button" style="display: none;">
                                Remove Address
                            </button><br>
                            <button class="submit-btn btn-large btn" type="submit">Save</button>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
</div>
<?php
    $width = 0;
    $height = 0;
?>

@if(!empty($fid))
    @if(!empty($foldagram_data))
    <?php
        $file = base_path().'/img/uploads/'.$foldagram_data->image;
        list($width, $height, $type, $attr) = getimagesize($file);
    ?>
    @endif

    <?php
        $width = $width;
        $height = $height;
        $vertical = "";
        $vertical_parrent = '';

        if($height>$width){
            $vertical = "vertical-body";
            $vertical_parrent = "vertical-parrent";
        }
    ?>

    <div id="hpreview" class="modal {{ $vertical_parrent }} hide fade" 
         tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <div class="modal-body {{ $vertical }}">
            @if(Session::has('dsuccess'))
                <div class="alert alert-success">
                    {{ Session::get('dsuccess') }}
                </div>
            @endif
            @if(Session::has('derror'))
                <div class="alert alert-error">
                    {{ Session::get('derror') }}
                </div>
            @endif
            <div class="cfrom-wapper">
                <?php if($width>$height): ?>
                <div class="horizontal">
                    <img src="{{ asset('img/create-form-flow.png') }}"/>
                    <div class="textmessage">
                        <?php
                            $order = array("\r\n", "\n", "\r");
                            $text = str_replace($order, "<br/>", $foldagram_data->message);
                            $text = wordwrap($text, 60, "<br/>");
                            echo preg_replace("/\s/", '&nbsp', $text);
                        ?>
                    </div>
                    <div class="imgpreview">
                        <img src="{{ asset('img/uploads/'.$foldagram_data->image) }}" 
                            alt="Foldagram image" id="phimg"/>
                    </div>
                    <div class="submit">
                        <div class="submit-content">
                            <button type="button" class="edit-btn btn-large btn">Edit</button><br/>
                            <button type="button" class="approve-btn btn-large btn">Approve</button>
                        </div>
                    </div>
                    
                </div>
                <?php endif; ?>

                <?php if($height>$width): ?>
                <div class="vertical">
                    <img src="{{ asset('img/vertical-preview.png') }}" />
                    <div class="textmessage">
                        <?php
                            $order = array("\r\n", "\n", "\r");
                            $text = str_replace($order, "<br/>", $foldagram_data->message);
                            $text = wordwrap($text, 60, "<br/>");
                            echo preg_replace("/\s/", '&nbsp', $text);
                        ?>
                    </div>
                    <div class="imgpreview">
                        <img src="{{ asset('img/uploads/'.$foldagram_data->image) }}" 
                             alt="Foldagram image" id="phimg"/>
                    </div>
                    <div class="submit">
                        <div class="submit-content">
                            <button type="button" class="edit-btn btn-large btn">Edit</button><br/>
                            <button type="button" class="approve-btn btn-large btn">Approve</button>
                        </div>
                    </div>
                    
                </div>
                <?php endif ?>
            </div>
            <div id="raddress" class="scroll-pane-os jspScrollable">
                <?php $i = 1; ?>
                @foreach($foldagram_address as $value)
                    <div class="address_list" id="{{ $value->id }}">
                        <div class="fromaddress">
                            <p><strong>Recipient # {{ $i++ }}</strong></p>
                            The Foldagram<br/>
                            PO, Box 1330<br/>
                            Avon, CO 81620
                        </div>
                        <div class="toaddress">
                            <div class="dispaddress">
                                <p>
                                    <strong>{{ $value->fullname }}</strong><br/>
                                    <?php 
                                        $text = preg_replace("/[\r\n]+/", "\n", $value->address_one);
                                        $text = wordwrap($text, 120, '<br/>', true);
                                        echo $text = nl2br($text);
                                    ?>
                                </p>
                            </div>
                            <div class="editaddress" style="display:none;" >
                                {{ Form::hidden('rid_'.$value->id, $value->id) }}
                                {{ Form::text('fullname_'.$value->id, $value->fullname, 
                                    array('placeholder' => 'Full Name* :', 'class' => 'required')) }}
                                {{ Form::textarea('address_one_'.$value->id, $value->address_one, 
                                    array(
                                        'placeholder' => 'Enter Recipient\'s Address here *:',
                                        'rows'        => '3',
                                        'class'       => 'required'
                                ))}}
                            </div>    
                        </div>
                        <button class="editradd btn-large btn" value="{{ $value->id }}" type="button">Edit</button>
                        <a href="{{ URL::to('remove/'.$value->id.'/'.$identifier) }}" 
                           class="removeadd btn btn-danger">
                           Remove
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <?php if(Session::get("redirect")): ?>
    <script type="text/javascript">
        $("#hpreview").modal('show');
        <?php if(!empty($fid)): ?>
            $(".recipient_address_wapper .recipient_address input").removeClass("required");
            $(".recipient_address_wapper .recipient_address textarea").removeClass("required");
        <?php endif; ?>
    </script>
    <?php endif; ?>
@endif
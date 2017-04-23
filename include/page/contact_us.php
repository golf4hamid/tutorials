
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-primary text-center" id="myModalLabel">Contact Us</h4>
      </div>
				<form class="form-group row" onsubmit="sendMessage(); return false;">
			        <div class="row">
			            <div class="input-group input-group-field  col-xs-10 col-xs-offset-1">
			                <label class="input-group-addon">First Name  </label>
			                <input type="text" class="form-control" id="f_name" placeholder="First Name..." required/>
			            </div>
			            <div class="input-group input-group-field  col-xs-10 col-xs-offset-1 ">
			                <label class="input-group-addon">Last Name  </label>
			                <input type="text" class="form-control" id="s_name" placeholder="Last Name..." required/>
			            </div>
			        </div>
			        <div class="row">
			            <div class="input-group input-group-field   col-xs-10 col-xs-offset-1">
			                <label class="input-group-addon">E-mail </label>
			                <input class="form-control" type="email" id="email" placeholder="Your Email..." required/>
			            </div>
			            <div class="input-group input-group-field  col-xs-10 col-xs-offset-1">
			                <label class="input-group-addon">Subjet </label>
			                <input type="text" class="form-control" id="subject" placeholder="What it is about.." required/>
			            </div>
			        </div>
			        <div class="row">
			            <div class="input-group col-xs-10 col-xs-offset-1">
			                <label class="input-group-addon">Your Message Goes Here </label>
			                <textarea resizable="false" class="form-control" placeholder="Your Message Goes Here..." id="message" required></textarea>
			            </div>
			        </div>
			        <div class="row">
			            <button id="save_tot" class="submit btn btn-primary btn-md" type="submit">Send!</button>
			        </div>
				</form>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				</div>
				</div>
				</div>

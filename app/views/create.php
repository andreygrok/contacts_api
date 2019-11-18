<div class="create_contacts">
    <div class="create_page row">
        <div class="col">
            <h2>Request</h2>
            <div class="form-group">
                <label for="exampleFormControlSelect2">Choose source</label>
                <select class="form-control source" name="source_id">
                    <option>1</option>
                    <option>2</option>
                </select>
            </div>
            <form class="form_create">
                <div class="create_row">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Enter Name contact" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone" placeholder="Enter phone number" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="email" placeholder="Enter email adress" class="form-control"/>
                    </div>
                </div>
            </form>
            <span class="add_rows"></span>
            <div class="for_clone">
                <form class="form_create clone_form">
                    <div class="create_row">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Enter Name contact" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <input type="text" name="phone" placeholder="Enter phone number" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <input type="text" name="email" placeholder="Enter email adress" class="form-control"/>
                        </div>
                    </div>
                </form>
            </div>
            <button type="button" class="btn add-row-btn btn-success">add more contact...</button>
            <br/>
            <input type="hidden" name="send" value="1"/>
            <button type="button" class="sbmt btn btn-primary mb-2 text-right">Submit contacts</button>
        </div>
        <div class="col">
            <h2>Response</h2>
            <div class="response">
                <div class="alert alert-success result_ok" role="alert"></div>
                <div class="alert alert-danger result_err" role="alert"></div>
            </div>
        </div>
    </div>
</div>

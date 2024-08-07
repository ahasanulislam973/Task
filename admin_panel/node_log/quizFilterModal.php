<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
     id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Filter Submission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="" id="submit_form" autocomplete="off">

                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label class="control-label ">
                            Set Date Range *</label>

                        <input class="form-control" type="text"
                               name="daterange" autocomplete="off"/>
                    </div>

                    <div class="clearfix"></div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="messenger_id">Messenger ID</label>
                        <input class="form-control" type="number" id="messenger_id" name="messenger_id"
                               value="<?php if (isset($_REQUEST['messenger_id'])) echo $_REQUEST['messenger_id']; ?>">
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="sourceNode">Landing Node </label>
                        <input class="form-control" type="text" id="sourceNode" name="sourceNode"
                               value="<?php if (isset($_REQUEST['sourceNode'])) echo $_REQUEST['sourceNode']; ?>">
                    </div>
                    <div class="clearfix"></div>

                    <input type="hidden" id="first_date" name="first_date"
                           value="<?php if (isset($_REQUEST['first_date'])) echo $_REQUEST['first_date']; ?>">
                    <input type="hidden" id="last_date" name="last_date"
                           value="<?php if (isset($_REQUEST['first_date'])) echo $_REQUEST['last_date']; ?>">
                    <div class="clearfix"></div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                        <!--<input type="submit" class="btn btn-info btn-block btn-sm"
                               name="filter" id="filter"
                               value="Apply Filter">-->

                        <button onclick="form_submit()" name='filter' id="filter" value='Apply Filter'
                                class="btn btn-info btn-block btn-sm"> Apply Filter
                        </button>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                        <a href="node_log_raw_data.php" <span
                                class="btn btn-danger btn-block btn-sm"> Clear Filter</span>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function form_submit() {
        document.getElementById("submit_form").submit();
    }

    var url = '<?php echo $quizCategoryNameUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id'];?>';
    let dropdown = $('#category_id');
    dropdown.empty();
    /*   dropdown.append('<option  disabled>Choose Category</option>');*/
    dropdown.prop('selectedIndex', 0);
    // Populate dropdown with list of provinces
    $.getJSON(url, function (data) {
        $.each(data, function (key, entry) {
            dropdown.append($('<option></option>').attr('value', key).text(entry));
            console.log('key', key, 'value', entry);
            var theValue = '<?php if (isset($_REQUEST['category_id'])) echo $_REQUEST['category_id'];?>';
            // alert('catid=' + theValue);
            $('option[value=' + theValue + ']')
                .attr('selected', true);
        })
        populateQuiz();
    });

    function populateQuiz() {

        var category_id = $('.quiz_category_id option:selected').val();

        let dropdown = $('#quiz_id');
        dropdown.empty();
        /*  dropdown.append('<option  disabled>Choose Quiz</option>');*/
        dropdown.prop('selectedIndex', 0);
        var url = '<?php echo $quizNameUrl;?>' + '?quiz_category_id=' + category_id;

        // Populate dropdown with list of provinces
        $.getJSON(url, function (data) {
            $.each(data, function (key, entry) {
                dropdown.append($('<option></option>').attr('value', key).text(entry));
                console.log('key', key, 'value', entry);
                var theValue = '<?php if (isset($_REQUEST['quiz_id'])) echo $_REQUEST['quiz_id'];?>';
                //  alert(theValue);
                $('option[value=' + theValue + ']')
                    .attr('selected', true);
            })
        });
    }
</script>
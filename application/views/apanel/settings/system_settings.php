<?php if ($this->session->flashdata('success')) { ?>

    <div class="alert alert-success fade in">

        <button type="button" class="close" data-dismiss="alert">

            <span aria-hidden="true">×</span>

        </button>

        <?php echo $this->session->flashdata('success'); ?>

    </div>

<?php }
if ($this->session->flashdata('error')) { ?>

    <div class="alert alert-danger fade in">

        <button type="button" class="close" data-dismiss="alert">

            <span aria-hidden="true">×</span>

        </button>

        <?php echo $this->session->flashdata('error'); ?>

    </div>

<?php } ?>

<div class="panel-body panel-form">


    <form class="form-horizontal form-bordered" method="post" data-parsley-validate="true" name="demo-form"
          action="<?php echo base_url() ?>apanel/system_settings/do_update">

        <div class="col-md-6 col-sm-6">

            <div class="note note-info">

                <h4><?php echo get_phrase('system_settings'); ?>!</h4>


            </div>

            <div class="form-group">

                <label class="control-label col-md-4 col-sm-4" for="fullname"><?php echo get_phrase('system_name'); ?> *
                    :</label>

                <div class="col-md-8 col-sm-8">

                    <input class="form-control" type="text" id="system_name" name="system_name"
                           value="<?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description; ?>"
                           placeholder="<?php echo get_phrase('system_name'); ?>" data-parsley-required="true"/>

                </div>

            </div>

            <div class="form-group">

                <label class="control-label col-md-4 col-sm-4" for="email"><?php echo get_phrase('system_title'); ?>*
                    :</label>

                <div class="col-md-8 col-sm-8">

                    <input class="form-control" type="text" id="system_title" name="system_title"
                           placeholder="<?php echo get_phrase('system_title'); ?>" data-parsley-required="true"
                           value="<?php echo $this->db->get_where('settings', array('type' => 'system_title'))->row()->description; ?>"/>

                </div>

            </div>

            <div class="form-group">

                <label class="control-label col-md-4 col-sm-4" for="website"><?php echo get_phrase('address'); ?>
                    :</label>

                <div class="col-md-8 col-sm-8">

                    <input class="form-control" type="text" id="address" name="address"
                           value="<?php echo $this->db->get_where('settings', array('type' => 'address'))->row()->description; ?>"
                           data-parsley-required="true" placeholder="<?php echo get_phrase('address'); ?>"/>

                </div>

            </div>

            <div class="form-group">

                <label class="control-label col-md-4 col-sm-4" for="message">Phone :</label>

                <div class="col-md-8 col-sm-8">

                    <input class="form-control cust_phone_no" type="text" name="phone"
                           value="<?php echo $this->db->get_where('settings', array('type' => 'phone'))->row()->description; ?>"
                           placeholder="(XXX) XXXX XXX"/>

                </div>

            </div>


            <div class="form-group">

                <label class="control-label col-md-4 col-sm-4" for="email"><?php echo get_phrase('system_email'); ?>
                    :</label>

                <div class="col-md-8 col-sm-8">

                    <input class="form-control" type="text" id="system_email" name="system_email"
                           value="<?php echo $this->db->get_where('settings', array('type' => 'system_email'))->row()->description; ?>"
                           data-parsley-type="email" placeholder="Email" data-parsley-required="true"
                           data-affixes-stay="true" data-prefix="" data-thousands=" " data-decimal="."
                    />

                </div>

            </div>

            <div class="form-group">

                <label class="control-label col-md-4 col-sm-4"
                       for="email"><?php echo get_phrase('Incoming Call Charges'); ?> :</label>

                <div class="col-md-8 col-sm-8">

                    <input class="form-control maskreal"   type="text" id="call_charge" name="call_charge"
                           value="<?php echo $this->db->get_where('settings', array('type' => 'call_charge'))->row()->description; ?>"
                           placeholder="Call Charges" data-parsley-required="true"
                           data-affixes-stay="true" data-prefix="" data-thousands=" " data-decimal="."
                    />

                </div>

            </div>


            <div class="form-group">

                <label class="control-label col-md-4 col-sm-4"
                       for="email"><?php echo get_phrase('Lookup Call Charges'); ?> :</label>

                <div class="col-md-8 col-sm-8">

                    <input class="form-control maskreal"   type="text" id="lookup_call_charge" name="lookup_call_charge"
                           value="<?php echo $this->db->get_where('settings', array('type' => 'lookup_call_charge'))->row()->description; ?>"
                           placeholder="Lookup Call Charges" data-parsley-required="true"
                           data-affixes-stay="true" data-prefix="" data-thousands=" " data-decimal="."
                    />

                </div>

            </div>

            <div class="form-group">

                <label class="control-label col-md-4 col-sm-4"
                       for="email"><?php echo get_phrase('call forward charges'); ?> :</label>

                <div class="col-md-8 col-sm-8">

                    <input class="form-control maskreal"   type="text" id="call_forword_charges" name="call_forword_charges"
                           value="<?php echo $this->db->get_where('settings', array('type' => 'call_forword_charges'))->row()->description; ?>"
                           placeholder="Call Forward Charges" data-parsley-required="true"
                           data-affixes-stay="true" data-prefix="" data-thousands=" " data-decimal="."
                    />

                </div>

            </div>


            <!-- campos novos -->

            <div class="form-group">

                <label class="control-label col-md-4 col-sm-4" for="website">Call Recording Price :</label>

                <div class="col-md-8 col-sm-8">

                    <input class="form-control maskreal"   type="text" id="p_call_recording" name="p_call_recording"
                           value="<?php echo $this->db->get_where('settings', array('type' => 'p_call_recording'))->row()->description; ?>"
                           data-parsley-required="true"
                           data-affixes-stay="true" data-prefix="" data-thousands=" " data-decimal="."
                    />

                </div>

            </div>


            <div class="form-group">

                <label class="control-label col-md-4 col-sm-4" for="website">Transc. Service Price :</label>

                <div class="col-md-8 col-sm-8">

                    <input class="form-control maskreal"   type="text" id="p_transc_service" name="p_transc_service"
                           value="<?php echo $this->db->get_where('settings', array('type' => 'p_transc_service'))->row()->description; ?>"
                           data-parsley-required="true"
                           data-affixes-stay="true" data-prefix="" data-thousands=" " data-decimal="."
                    />

                </div>

            </div>


            <div class="form-group">

                <label class="control-label col-md-4 col-sm-4" for="website">Social Media Adv. Price :</label>

                <div class="col-md-8 col-sm-8">

                    <input class="form-control maskreal"  type="text" id="p_social_med_adv" name="p_social_med_adv"
                           value="<?php echo $this->db->get_where('settings', array('type' => 'p_social_med_adv'))->row()->description; ?>"
                           data-parsley-required="true"
                           data-affixes-stay="true" data-prefix="" data-thousands=" " data-decimal="."
                    />

                </div>

            </div>


            <div class="form-group">

                <label class="control-label col-md-4 col-sm-4" for="website">Block Spam Calls Price :</label>

                <div class="col-md-8 col-sm-8">

                    <input class="form-control maskreal"  type="text" id="p_blk_spam_calls" name="p_blk_spam_calls"
                           value="<?php echo $this->db->get_where('settings', array('type' => 'p_blk_spam_calls'))->row()->description; ?>"
                           data-parsley-required="true"
                           data-affixes-stay="true" data-prefix="" data-thousands=" " data-decimal="."
                    />

                </div>

            </div>
            <!-- Fim campos novo -->

            <div class="note note-info">

                <h4><?php echo get_phrase('Account API credentials'); ?>!</h4>


            </div>

            <div class="form-group">

                <label class="control-label col-md-4 col-sm-4" for="email"><?php echo get_phrase('Account SID'); ?>
                    :</label>

                <div class="col-md-8 col-sm-8">

                    <input class="form-control maskreal" type="text" id="account_sid" name="account_sid"
                           value="<?php echo $this->db->get_where('settings', array('type' => 'account_sid'))->row()->description; ?>"
                           placeholder="Account SID" data-parsley-required="true"/>

                </div>
                <label class="control-label col-md-4 col-sm-4"
                       for="email"><?php echo get_phrase('Account Auth Token'); ?> :</label>

                <div class="col-md-8 col-sm-8">

                    <input class="form-control maskreal" type="text" id="account_token" name="account_token"
                           value="<?php echo $this->db->get_where('settings', array('type' => 'account_token'))->row()->description; ?>"
                           placeholder="Auth Token" data-parsley-required="true"
                    />

                </div>

            </div>


            <div class="form-group">

                <label class="control-label col-md-4 col-sm-6"></label>

                <div class="col-md-6 col-sm-6">

                    <button type="submit" class="btn btn-primary">Submit</button>

                </div>

            </div>


        </div>

    </form>

    <div class="col-md-6 col-sm-6">

        <form class="form-horizontal form-bordered" method="post" data-parsley-validate="true" name="demo-form"
              action="<?php echo base_url() ?>apanel/system_settings/upload_logo"
              enctype="multipart/form-data">

            <div class="note note-info">

                <h4>                    <?php echo get_phrase('System Logo upload'); ?>!</h4>


                <ul>

                    <li>The maximum file size for uploads in this demo is <strong>2 MB</strong> .</li>

                    <li>Only image files (<strong>JPG, GIF, PNG</strong>) are allowed in this demo (by default there is
                        no file type restriction).
                    </li>

                </ul>


            </div>

            <div class="form-group">

                <label class="control-label col-md-4 col-sm-4"
                       for="message"><?php echo get_phrase('Site Logo'); ?></label>

                <div class="col-md-8 col-sm-8">

                    <div class="fileinput fileinput-new" data-provides="fileinput" style="overflow:hidden;">

                        <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;"
                             data-trigger="fileinput">

                            <img src="<?php echo base_url() . 'uploads/logo.png'; ?>" alt="..." style="height:100%;">

                        </div>


                        <div>

                                      <span class="btn btn-white btn-file" style="overflow:hidden;">

                                            <i class="fa fa-plus"></i>

                                    <span>Add file...</span>

									<input type="file" name="userfile" accept="image/*" class="btn btn-primary start">

                                </span>

                            </span>

                        </div>

                    </div>

                </div>

            </div>


            <div class="form-group">

                <div class="col-md-8 col-md-offset-4">

                    <div class="input-append input-group">

                        <button type="submit"
                                class="btn btn-warning"><?php echo get_phrase('update Changes'); ?></button>
                    </div>

                </div>

            </div>

        </form>

    </div>


</div>
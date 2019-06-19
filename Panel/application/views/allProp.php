<main class="main-container">
    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#">Vendor Products </a>
                        </li>
                        <li class="active"><span> All Properties</span></li>
                    </ol>
                    <div class="page-header">
                        <h2 class="page-subtitle">
                            Properties Name
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div  class="panel panel-white">
        <div  class="panel-body  pb">

            <?= $this->session->flashdata('msg'); ?>
            <?= form_open('SadminLogin/propname'); ?>
            <div class="row">

                <div class="col-md-3 col-md-offset-3">
                    <label for="">Property Name</label>   
                    <input type="text" required="" class="form-control" name="propname" value="" />
                    <?= form_error('propname', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="col-md-3">
                    <br/>
                    <button class="btn btn-sm btn-success">Add</button>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
        <div  class="panel-body  pb">
            <div class="table-responsive">

                <table class="table table-bordered table-striped table-nowrap no-mb">


                    <thead>
                        <tr>
                            <th>Property Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        
                        foreach ($properties as $property) { ?>
                            <tr>
                                <td><?= $property->pop_name ?></td>
                                <td><a href="<?= site_url('SadminLogin/deletename/') ?><?= $this->encrypt->encode($property->id) ?>" class="btn btn-xs btn-danger"> Delete </a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</main>

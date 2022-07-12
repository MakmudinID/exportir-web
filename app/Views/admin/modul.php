<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Modul</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Setting</a></li>
            <li class="breadcrumb-item active">Modul</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Group</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal fade" id="mdl-modul" tabindex="-1" role="dialog" aria-labelledby="Modul" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content" id="mdl-layanan">
                            <div class="modal-header">
                                <h5 class="modal-title" id="title_modal"></h5>
                                <button type="button" class="btn-close" id="hide" data-bs-dismiss="modal"></button>
                            </div>
                            <form id="add-form" class="form-horizontal">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label class="col-form-label">Nama</label>
                                                        <input type="hidden" id="hidden_id" name="hidden_id" />
                                                        <input type="text" name="nama" id="nama" class="form-control" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label class="col-form-label">Group</label>
                                                        <input type="text" name="group" id="group" class="form-control" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label class="col-form-label">Status</label>
                                                        <select class="form-control" name="status" id="status">
                                                            <option value="">Pilih</option>
                                                            <option value="ACTIVE">ACTIVE</option>
                                                            <option value="INACTIVE">INACTIVE</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer" id="foot">
                                    <button type='button' class='btn btn-default' id="hide" data-bs-dismiss='modal'>Close</button>
                                    <button type="submit" id="submit_" class='btn btn-primary'></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
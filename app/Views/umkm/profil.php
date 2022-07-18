<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">User Profile</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="<?= $get_profil->foto?>" alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center"><?= $get_profil->nama ?></h3>
                        <p class="text-muted text-center"><?= $get_profil->nama_umkm ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <h4>Data Profile</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" id="edit-profil">
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?= $get_profil->email ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?= $get_profil->nama ?>">
                                    <input type="hidden" class="form-control" name="id" id="id"  value="<?= $get_profil->id ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nohp" class="col-sm-2 col-form-label">Nomor Hp</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nohp" id="nohp" placeholder="Nomor Hp" value="<?= $get_profil->no_hp ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Update Profil</button>
                                </div>
                            </div>
                        </form>
        
                    </div>
            
                </div>
            </div>

        </div>
    </div>
</section>

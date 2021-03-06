<div class="container-fluid">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h5 class="m-0 font-weight-bold text-primary">Data Prove</h5>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th width="5%" class="text-center">No</th>
							<th width="20%">Nama Peminta</th>
							<th width="5%">Angkatan</th>
							<th width="25%">Pembimbing</th>
							<th width="10%">Materi</th>
							<th width="15%">Deskripsi BAB</th>
							<th width="10%">Status</th>
							<th width="10%">Detail</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no=1;
						foreach($record as $data):
                        ?>
						<tr>
							<td class="text-center"><?= $no++ ?></td>
							<td><?= $data->nama_eksternal ?></td>
							<td><?= $data->angkatan ?></td>
							<td><?= $data->nama_internal ?></td>
							<td><?= $data->nama_materi ?></td>
							<td><?= $data->deskripsi_materi ?></td>
							<td>
								<?php if($data->status_prove == "Selesai")
                                {
                                    echo '<span class="badge badge-success">Done</span>';
                                }
                                else {
                                    echo '<span class="badge badge-danger">unfinished</span>';
                                }   
                            ?>
							</td>
							<td>
								<a href="#" class="btn-sm btn-info" id="btn_search" data-toggle="modal"
									data-target="#exampleModalCenter" data-idprove="<?= $data->id_prove ?>">
									Detail
								</a>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="modal fade  bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog"
	aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Detail Anggota Prove</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table table-bordered table_1" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">Nama</th>
								<th class="text-center">Angkatan</th>
							</tr>
						</thead>
						<tbody id="daftar_barang">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?= base_url(); ?>assets/sb_admin_2/vendor/jquery/jquery.min.js"></script>
<script>
	$('#btn_search').on('click', function () {
		var id_prove = $(this).data("idprove");
		var table;
		table = $('.table_1').DataTable({
			"columnDefs": [{
				"targets": [0, 2],
				"className": "text-center"
			}],
			"bDestroy": true
		});
		table.clear();
		$.ajax({
			url: "<?php echo base_url() . 'admin/prove/detail_anggota_prove'; ?>",
			method: "POST",
			data: {
				id_prove: id_prove
			},
			success: function (hasil) {
				var obj = JSON.parse(hasil);
				let data = obj['tbl_data'];
				if (data != '') {
					var no = 1;
					$.each(data, function (i, item) {
						var nama = data[i].nama;
						var angkatan = data[i].angkatan;
						table.row.add([no, nama, angkatan]);
						no = no + 1;
					});
				} else {
					$('.table_1').html('<h3>No data are available</h3>');
				}
				table.draw();
			}
		});
	});

</script>

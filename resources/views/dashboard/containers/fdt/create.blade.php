<!-- Button trigger modal -->
<div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        Add FDT
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add FDT</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createClusterForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Cluster Name</label>
                        <input type="text" class="form-control" id="name" name="name" required
                            placeholder="Ex: SBT-PLTD.AIRRAJA-RC6820-OLT-01">
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Next & Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

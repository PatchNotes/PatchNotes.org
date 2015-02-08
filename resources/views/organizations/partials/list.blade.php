<div class="row projects-list">
    @foreach($organizations as $org)

    <div class="col-md-3">
        <a href="{{ $org->href }}" class="thumbnail project">
            <div class="project-caption">
                <h2 class="project-header"><span>{{ $org->name }}</span></h2>
                <p>{{ str_limit($org->description, 50) }}</p>
            </div>
            <div class="modal-footer" style="text-align: left">
                <div class="row project-info">
                    <div class="col-md-6 text-center">
                        <b>{{ count($org->projects) }}</b><br/><small>Projects</small>
                    </div>
                    <div class="col-md-6 text-center">
                    </div>
                </div>
            </div>
        </a>
    </div>

    @endforeach
</div>

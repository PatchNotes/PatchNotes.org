<div class="row projects-list">
    @foreach($projects as $project)

    <div class="col-md-3">
        <a href="{{ $project->href }}" class="thumbnail project">
            <div class="project-caption">
                <h2 class="project-header"><span>{{{ $project->name }}}</span></h2>
                <p>{{{ str_limit($project->description, 50) }}}</p>
            </div>
            <div class="modal-footer" style="text-align: left">
                <div class="row project-info">
                    <div class="col-md-6 text-center">
                        <b>{{ $project->subscriberCount() }}</b><br/><small>Subscribers</small>
                    </div>
                    <div class="col-md-6 text-center">
                        <b>{{ $project->updates()->count() }}</b><br/><small>Updates</small>
                    </div>
                </div>
            </div>
        </a>
    </div>

    @endforeach
</div>

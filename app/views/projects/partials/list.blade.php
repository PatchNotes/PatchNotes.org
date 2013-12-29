<div class="row projects">
    @foreach($projects as $project)

    <div class="col-md-3">
        <a href="/projects/{{ $project->slug }}" class="thumbnail project">
            <div class="caption">
                <h2 class="textfill"><span>{{{ $project->name }}}</span></h2>
                <p>{{{ Str::limit($project->description, 50) }}}</p>
            </div>
            <div class="modal-footer" style="text-align: left">
                <div class="row project-info">
                    <div class="col-md-6 text-center">
                        <b>{{ $project->subscribers()->count() }}</b><br/><small>Subscribers</small>
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
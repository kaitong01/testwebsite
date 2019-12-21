<select class="form-control {{$cls ?? ''}}"{{$attr ?? ''}}

    @isset($id)
        id="{{$id}}"
    @endisset

    @isset($name)
        name="{{$name}}"
    @endisset

    @isset($action)
        data-action="{{$action}}"
    @endisset
    >
    @foreach ($items as $item)
    <option
    @isset($active)
        {{$item['id']===$active ? ' selected="1"': ''}}
    @endisset
    value="{{$item['value'] ?? $item['id']}}">{{$item['name']}}</option>
    @endforeach
</select>

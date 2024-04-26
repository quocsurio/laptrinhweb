@extends('nav.header')

@section('content')
<div class="container mt-5">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>

            @foreach($users as $user)
            <tr>

                <td><img src="data:image;base64,{{ $user->image }}" alt="image" style="width: 50px; height: 50px;" /></td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>
                    <a href="{{ route('user.show', ['id' => $user->id]) }}" class="btn btn-info btn-sm">
                        <span class="material-icons">visibility</span> Chi tiết
                    </a>
                    <a href="{{ route('user.edit', ['id' => $user->id]) }}" class="btn btn-warning btn-sm">
                        <span class="material-icons">edit</span> Sửa
                    </a>
                    <a href="{{ route('user.delete', ['id' => $user->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chăc muốn xóa?')">
                        <span class="material-icons">delete</span> Xóa
                    </a>
                    <a href="" class="btn btn-warning btn-sm">
                        <span class="material-icons">favorite</span> Sở thích
                    </a>

                    <a href="{{ route('user.posts', ['id' => $user->id]) }}" class="btn btn-warning btn-sm">
                        <span class="material-icons">edit</span> Bài viết
                    </a>
                   

                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        <nav aria-label="Page navigation">
            <ul class="pagination">


                @if (!$users->onFirstPage())
                {{-- Nếu không phải trang đầu tiên, tạo nút "<" --}}
                <li class="page-item">
                    <a href="{{ $users->previousPageUrl() }}" class="page-link">
                        <span aria-hidden="true">
                            << /span>
                    </a>
                </li>
                @endif

                {{-- Số trang --}}
                {{-- Duyệt qua các trang và hiển thị số trang --}}
                @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                {{-- Hiển thị số trang --}}
                <li class="page-item {{ $page == $users->currentPage() ? 'active' : '' }}">
                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                </li>
                @endforeach

                {{-- Kiểm tra nếu còn trang tiếp theo --}}
                @if ($users->hasMorePages())
                {{-- Nếu còn trang tiếp theo, tạo nút "Next" --}}
                <li class="page-item">
                    <a href="{{ $users->nextPageUrl() }}" class="page-link" aria-label="Next">
                        <span aria-hidden="true">></span>
                    </a>
                </li>

                @endif
            </ul>
        </nav>
    </div>

</div>
@endsection
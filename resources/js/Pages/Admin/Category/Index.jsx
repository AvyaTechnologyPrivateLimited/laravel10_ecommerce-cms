import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';
import { Inertia } from '@inertiajs/inertia';

export default function Index({ auth, data }) {
    function destroy(e) {
        if (confirm("Are you sure you want to delete this item?")) {
            Inertia.delete(route("admin.category.destroy", e.currentTarget.id));
        }
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Category</h2>}
        >
            <Head title="Create Category" />

          <div className='body flex-grow-1 px-3'>
            <div className='container-lg'>
            <div className="card mb-4">
  <div className="card-header">
  <strong>Category</strong>
  <Link className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded pull-right" href={route("admin.category.create")}>
    <span className="hidden md:inline">Create</span>
</Link>
  </div>
  <div className="card-body">
                        <div className="table-responsive">
                        
                        <table className="w-full whitespace-nowrap">
                        <thead>
                            <tr className="font-bold text-left">
                                <th className='py-2'>#</th>
                                <th className='py-2'>Icon</th>
                                <th className='py-2'>Title</th>
                                <th className='py-2'>Slug</th>
                                <th className='py-2'>Total Products</th>
                                <th className='py-2'>Status</th>
                                <th className='py-2'>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {data.map(({ id, image, title, slug, status, products_count }) => (
                                <tr key={id} className="">
                                    <td className="border-t py-2">
                                        {id}
                                    </td>
                                    <td className="border-t py-2">
                                        {!image ? 'No Preview' : (
                                            <img width='40px' src={image} />
                                        )}
                                    </td>
                                    <td className="border-t py-2">
                                        {title}
                                    </td>
                                    <td className="border-t py-2">
                                        {slug}
                                    </td>
                                    <td className="border-t py-2">
                                        {products_count}
                                    </td>
                                    <td className="border-t py-2">
                                        {status=='Active' ? (<span className='badge badge-success'>Active</span>) : (<span className='badge badge-dark'>Inactive</span>)}
                                    </td>
                                    <td className="border-t py-2">
                                        <Link
                                            href={route("admin.category.edit", id)}
                                            className="pl-2 text-violet-800"
                                        >
                                           <i className='fa fa-pencil' title='Edit' alt='Edit'></i>
                                        </Link>

                                        <button
                                            onClick={destroy}
                                            className="pl-2 text-rose-700"
                                            id={id}
                                        >
                                           <i className='fa fa-trash' title='Delete' alt='Delete'></i>
                                        </button>

                                    </td>
                                </tr>
                            ))}
                            {data.length === 0 && (
                                <tr>
                                    <td
                                        className="px-6 py-4 border-t"
                                        colSpan="4"
                                    >
                                        No contacts found.
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                    
                        </div>
                    </div>
  </div>
</div>
</div>

           
        </AuthenticatedLayout>
    );
}

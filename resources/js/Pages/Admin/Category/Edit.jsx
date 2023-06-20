import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm, usePage, Link } from '@inertiajs/react';

export default function Edit({ auth, status_options }) {

    const { category } = usePage().props;
    const { data, setData, post, errors, progress } = useForm({
        title: category.title || "",
        status: category.status,
        image: category.image || "",
        file: "",
    });

    const handleFileChange = (event) => {
        const file = event.target.files[0];
        setData('file', file);
      };

    const handleOptionChange = (option) => {
        setData('status', option.target.value);
    };
  
    function handleSubmit(e) {
        e.preventDefault();

        const formData = new FormData();
        formData.append('file', file);

        post(route("admin.category.update", category.id), formData, {
            headers: {
                'Content-Type': 'multipart/form-data', // Set the Content-Type header
            },
        });
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Edit Category</h2>}
        >
            <Head title="Edit Category" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            
                            <form onSubmit={handleSubmit} className="bg-white px-8 pt-6 pb-8 mb-4">
                                <div className="mb-4">
                                <label className="block text-gray-700 text-sm font-bold mb-2">
                                    Title
                                </label>
                                <input 
                                className="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" 
                                type="text" 
                                    placeholder="Titel"
                                    value={data.title}
                                    onChange={(e) =>
                                        setData("title", e.target.value)
                                    }
                                />
                                <span className="text-red-600">
                                    {errors.title}
                                </span>
                                </div>
                                <div className="mb-4">
                                <label className="block text-gray-700 text-sm font-bold mb-2">
                                    Icon
                                </label>
                                <input 
                                    className="appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" 
                                    type="file"
                                    name="file"
                                    id="file"
                                    placeholder="Icon"
                                    onChange={handleFileChange}
                                />
                                
                                <img src={data.image} width="40px" />
                                <span className="text-red-600">
                                    {errors.file}
                                </span>
                                </div>
                                <div className="mb-4">
                                
                                <label className="block text-gray-700 text-sm font-bold mb-2">
                                    Status
                                </label>
                                <select 
                                    value={category.status}
                                    onChange={handleOptionChange}
                                    className="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                    {status_options.map((option) => (
                                        <option key={option.value} value={option.value}>
                                            {option.label}
                                        </option>
                                    ))}
                                </select>

                                <span className="text-red-600">
                                    {errors.status}
                                </span>
                                </div>

                                {progress && (
                                  <div className="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                                    <div className="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" width={progress.percentage}> {progress.percentage}%</div>
                                  </div>
                                )}

                                <div className="flex items-center justify-between">
                                <button className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                    Update
                                </button>
                                </div>
                            </form>
                    
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

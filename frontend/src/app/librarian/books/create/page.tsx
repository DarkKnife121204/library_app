"use client";
import { useEffect, useState } from "react";
import { useRouter } from "next/navigation";
import Cookies from "js-cookie";

export default function CreateUserPage() {
    const router = useRouter();

    const [title, setTitle] = useState("");
    const [author, setAuthor] = useState("");
    const [genre, setGenre] = useState("");
    const [publisher, setPublisher] = useState("");
    
    const [authorized, setAuthorized] = useState(false);

    useEffect(() => {
        const checkAdmin = async () => {
            const token = Cookies.get("token");
            if (!token) return router.push("/");

            try {
                const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/me`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        Accept: "application/json",
                    },
                });

                if (!res.ok) throw new Error("Unauthorized");

                const data = await res.json();
                const user = data.data;

                if (user.role !== "librarian") return router.push(`/${user.role}`);

                setAuthorized(true);
            } catch {
                router.push("/");
            }
        };

        checkAdmin();
    }, [router]);

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        const token = Cookies.get("token");
        const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/book`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify({ title, author, genre, publisher }),
        });

        if (res.ok) {
            router.push("/librarian");
        } else {
            alert("Ошибка при добавлении книги");
        }
    };

    if (!authorized) {
        return (
            <div className="min-h-screen flex items-center justify-center bg-gray-100 px-4">
                <div className="p-6 bg-white shadow-md rounded text-center text-gray-800">
                    Загрузка...
                </div>
            </div>
        );
    }

    return (
        <div className="min-h-screen flex justify-center items-center bg-gray-100 px-4 py-10">
            <form
                onSubmit={handleSubmit}
                className="w-full max-w-lg bg-white p-8 rounded-xl shadow-lg space-y-6"
            >
                <h2 className="text-3xl font-bold text-center text-gray-800">
                    Добавление книги
                </h2>

                <input
                    type="text"
                    placeholder="Название"
                    value={title}
                    onChange={(e) => setTitle(e.target.value)}
                    className="w-full border border-gray-300 px-4 py-3 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />

                <input
                    type="text"
                    placeholder="Автор"
                    value={author}
                    onChange={(e) => setAuthor(e.target.value)}
                    className="w-full border border-gray-300 px-4 py-3 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />

                <input
                    type="text"
                    placeholder="Жанр"
                    value={genre}
                    onChange={(e) => setGenre(e.target.value)}
                    className="w-full border border-gray-300 px-4 py-3 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />

                <input
                    type="text"
                    placeholder="Издатель"
                    value={publisher}
                    onChange={(e) => setPublisher(e.target.value)}
                    className="w-full border border-gray-300 px-4 py-3 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />

                <div className="flex flex-col sm:flex-row gap-4">
                    <button
                        type="submit"
                        className="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-md transition"
                    >
                        Добавить
                    </button>

                    <button
                        type="button"
                        onClick={() => router.push("/librarian")}
                        className="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 rounded-md transition"
                    >
                        Назад в панель
                    </button>
                </div>
            </form>
        </div>
    );

}

"use client";

import { useEffect, useState } from "react";
import { useRouter, useSearchParams } from "next/navigation";
import Cookies from "js-cookie";

export default function CreateCommentPage() {
    const router = useRouter();
    
    const searchParams = useSearchParams();
    const bookId = searchParams.get("book");

    const [rating, setRating] = useState(1);
    const [content, setContent] = useState("");

    const [authorized, setAuthorized] = useState(false);

    useEffect(() => {
        const checkUser = async () => {
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
                setAuthorized(true);
            } catch {
                router.push("/");
            }
        };

        checkUser();
    }, [router]);

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();

        const token = Cookies.get("token");
        const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/comment`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify({
                book_id: Number(bookId),
                rating,
                content,
            }),
        });

        if (res.ok) {
            router.push(`/user/comments?book=${bookId}`);
        } else {
            alert("Ошибка при добавлении комментария");
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
                    Оставить комментарий
                </h2>

                <input
                    type="number"
                    placeholder="Оценка (1–5)"
                    value={rating}
                    onChange={(e) => setRating(Number(e.target.value))}
                    min={1}
                    max={5}
                    className="w-full border border-gray-300 px-4 py-3 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />

                <textarea
                    placeholder="Комментарий"
                    value={content}
                    onChange={(e) => setContent(e.target.value)}
                    rows={4}
                    className="w-full border border-gray-300 px-4 py-3 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />

                <div className="flex flex-col sm:flex-row gap-4">
                    <button
                        type="submit"
                        className="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-md transition"
                    >
                        Отправить
                    </button>
                    <button
                        type="button"
                        onClick={() => router.push(`/user/comments?book=${bookId}`)}
                        className="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 rounded-md transition"
                    >
                        Назад
                    </button>
                </div>
            </form>
        </div>
    );
}
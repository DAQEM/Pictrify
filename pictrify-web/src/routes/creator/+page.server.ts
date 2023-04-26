import type { PageServerLoad } from "./$types";

export const load: PageServerLoad = async ({ fetch }) => {
  const res = await fetch("http://localhost:8393/api/creator/");
  const creators = await res.json();

  return {
    creators
  };
};
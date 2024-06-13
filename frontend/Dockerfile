FROM node:20-alpine

RUN npm install -g npm@latest

WORKDIR /app/

COPY package.json ./

RUN npm install 

#RUN npm list vite

COPY . .

ENV PATH /app/node_modules/.bin:$PATH

EXPOSE 5174

#RUN npm run build
#FROM nginx:latest
#COPY --from=0 /app/dist /usr/share/nginx/html
#EXPOSE 80
#CMD ["nginx", "-g", "daemon off;"]

CMD ["npm","run","dev"]
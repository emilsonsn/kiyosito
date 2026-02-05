import os
import sys

def concatenate_files(root_dir, output_file):
    # Open the output file in write mode
    with open(output_file, 'w', encoding='utf-8') as outfile:
        # Walk through all directories and files
        for dirpath, _, filenames in os.walk(root_dir):
            for filename in filenames:
                file_path = os.path.join(dirpath, filename)
                try:
                    # Write the file path separator
                    outfile.write("================\n")
                    outfile.write(file_path + "\n")
                    outfile.write("----------------------\n")
                    
                    # Write the file content
                    with open(file_path, 'r', encoding='utf-8', errors='ignore') as infile:
                        outfile.write(infile.read())
                    outfile.write("\n")
                except Exception as e:
                    # Handle any errors (e.g., permission issues)
                    outfile.write(f"Error reading file: {e}\n")

if __name__ == "__main__":
    # Check if the directory argument is provided
    if len(sys.argv) != 2:
        print("Usage: python3 concatenate_files.py <directory>")
        sys.exit(1)

    # Get the directory of interest from the argument
    root_directory = sys.argv[1]

    # Check if the directory exists
    if not os.path.isdir(root_directory):
        print(f"Error: Directory '{root_directory}' does not exist.")
        sys.exit(1)

    # Define the output file
    output_filename = "concatenated_output.txt"

    # Call the function to concatenate files
    concatenate_files(root_directory, output_filename)
    print(f"Concatenation complete. Output saved to {output_filename}")
